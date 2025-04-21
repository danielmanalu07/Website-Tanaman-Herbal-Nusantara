import 'package:another_flushbar/flushbar.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:go_router/go_router.dart';
import 'package:image_picker/image_picker.dart';
import 'package:mobile_scanner/mobile_scanner.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'package:tsth_app/features/scanner/presentation/bloc/plant_bloc.dart';
import 'package:tsth_app/features/scanner/presentation/bloc/plant_event.dart';
import 'package:tsth_app/features/scanner/presentation/bloc/plant_state.dart';
import 'package:tsth_app/features/scanner/presentation/widgets/scanner_border_painter.dart';
import 'package:tsth_app/routes/initial_route.dart';

class QrScanScreen extends StatefulWidget {
  const QrScanScreen({super.key});

  @override
  State<QrScanScreen> createState() => _QrScanScreenState();
}

void showErrorFlushbar(BuildContext context, String message) {
  Flushbar(
    message: message,
    backgroundColor: Colors.red,
    duration: const Duration(seconds: 2),
    margin: const EdgeInsets.all(8),
    borderRadius: BorderRadius.circular(8),
    flushbarPosition: FlushbarPosition.TOP,
  ).show(context);
}

class _QrScanScreenState extends State<QrScanScreen>
    with SingleTickerProviderStateMixin {
  late AnimationController _animationController;
  late Animation<double> _animation;
  late MobileScannerController _mobileScannerController;
  bool _isScanning = false;

  @override
  void initState() {
    super.initState();
    _animationController = AnimationController(
      vsync: this,
      duration: const Duration(seconds: 2),
    )..repeat();

    _animation = Tween<double>(
      begin: 0.0,
      end: 1.0,
    ).animate(_animationController);

    // Initialize scanner controller with proper settings
    _mobileScannerController = MobileScannerController(
      detectionSpeed: DetectionSpeed.normal,
      facing: CameraFacing.back,
      torchEnabled: false,
      returnImage: false,
    );
  }

  @override
  void dispose() {
    _animationController.dispose();
    _mobileScannerController.stop();
    super.dispose();
  }

  void _processQRCode(String? barcodeValue) {
    if (barcodeValue == null) {
      showErrorFlushbar(context, 'QR/Barcode tidak terbaca.');
      setState(() => _isScanning = false);
      return;
    }

    try {
      final uri = Uri.tryParse(barcodeValue);
      if (uri != null && uri.pathSegments.isNotEmpty) {
        final plantId = uri.pathSegments.last;
        context.read<PlantBloc>().add(FetchPlantEvent(plantId));
      } else {
        // Fallback untuk QR yang hanya string ID
        if (barcodeValue.trim().isNotEmpty) {
          context.read<PlantBloc>().add(FetchPlantEvent(barcodeValue.trim()));
        } else {
          showErrorFlushbar(context, 'QR tidak valid: $barcodeValue');
          setState(() => _isScanning = false);
        }
      }
    } catch (e) {
      debugPrint('Error processing QR: $e');
      showErrorFlushbar(context, 'Error membaca QR code.');
      setState(() => _isScanning = false);
    }
  }

  Future<void> _onGalleryButtonPressed() async {
    final ImagePicker picker = ImagePicker();
    final XFile? pickedFile = await picker.pickImage(
      source: ImageSource.gallery,
    );

    if (pickedFile != null) {
      setState(() => _isScanning = true);
      final String path = pickedFile.path;
      try {
        final result = await _mobileScannerController.analyzeImage(path);
        if (result != null && result.barcodes.isNotEmpty) {
          final barcode = result.barcodes.first;
          _processQRCode(barcode.rawValue);
        } else {
          showErrorFlushbar(context, 'QR/Barcode tidak ditemukan.');
          setState(() => _isScanning = false);
        }
      } catch (e) {
        debugPrint('Error scanning image: $e');
        showErrorFlushbar(context, 'Gagal memindai gambar.');
        setState(() => _isScanning = false);
      }
    }
  }

  void _onDetect(BarcodeCapture capture) {
    final barcode = capture.barcodes.first;
    final String? rawValue = barcode.rawValue;

    if (rawValue != null && Uri.tryParse(rawValue)?.hasAbsolutePath == true) {
      debugPrint('Scanned QR URL: $rawValue');

      // Trigger bloc to load plant by URL or ID (depending on backend API)
      context.read<PlantBloc>().add(FetchPlantEvent(rawValue));

      // Navigate to validation screen after triggering fetch
      Future.delayed(const Duration(milliseconds: 500), () {
        context.go(InitialRoute.validationScreen);
      });
    } else {
      showErrorFlushbar(context, 'QR tidak valid');
    }
  }

  @override
  Widget build(BuildContext context) {
    return WillPopScope(
      onWillPop: () async {
        if (context.canPop()) {
          context.pop();
        } else {
          context.go(InitialRoute.homeScreen);
        }
        return false;
      },
      child: Scaffold(
        backgroundColor: ColorConstant.backgroundColor,
        appBar: AppBar(
          backgroundColor: Colors.transparent,
          elevation: 0,
          leading: IconButton(
            icon: const Icon(Icons.arrow_back, color: Colors.white),
            onPressed: () {
              if (context.canPop()) {
                context.pop();
              } else {
                context.go(InitialRoute.homeScreen);
              }
            },
          ),
          title: const Text(
            'Scan QR Tanaman',
            style: TextStyle(color: Colors.white),
          ),
        ),
        body: BlocListener<PlantBloc, PlantState>(
          listener: (context, state) {
            if (state is PlantLoading) {
              setState(() => _isScanning = true);
            } else if (state is PlantLoaded) {
              setState(() => _isScanning = false);
              context.go(InitialRoute.validationScreen);
            } else if (state is PlantError) {
              setState(() => _isScanning = false);
              showErrorFlushbar(context, state.message);
            }
          },
          child: Stack(
            children: [
              MobileScanner(
                controller: _mobileScannerController,
                onDetect: _onDetect,
                errorBuilder: (context, error, child) {
                  debugPrint('Scanner error: $error');
                  return Center(
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        const Icon(Icons.error, color: Colors.red, size: 64),
                        const SizedBox(height: 16),
                        Text(
                          'Kamera tidak tersedia: $error',
                          style: const TextStyle(color: Colors.white),
                          textAlign: TextAlign.center,
                        ),
                      ],
                    ),
                  );
                },
              ),
              // Scanner overlay with animation
              Center(
                child: SizedBox(
                  width: 250,
                  height: 250,
                  child: Stack(
                    children: [
                      CustomPaint(
                        painter: ScannerBorderPainter(),
                        child: Container(),
                      ),
                      AnimatedBuilder(
                        animation: _animationController,
                        builder: (context, child) {
                          return Positioned(
                            top: 250 * _animation.value,
                            left: 0,
                            right: 0,
                            child: Container(height: 2, color: Colors.white),
                          );
                        },
                      ),
                    ],
                  ),
                ),
              ),
              if (_isScanning)
                Container(
                  color: Colors.black.withOpacity(0.5),
                  child: const Center(
                    child: CircularProgressIndicator(color: Colors.white),
                  ),
                ),
              // Gallery button
              Align(
                alignment: Alignment.bottomCenter,
                child: Padding(
                  padding: const EdgeInsets.only(bottom: 80),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      GestureDetector(
                        onTap: _onGalleryButtonPressed,
                        child: CircleAvatar(
                          radius: 30,
                          backgroundColor: ColorConstant.whiteColor,
                          child: Icon(
                            Icons.photo_library,
                            size: 30,
                            color: ColorConstant.blackColor,
                          ),
                        ),
                      ),
                      const SizedBox(width: 20),
                      GestureDetector(
                        onTap: () async {
                          await _mobileScannerController.toggleTorch();
                        },
                        child: CircleAvatar(
                          radius: 30,
                          backgroundColor: ColorConstant.whiteColor,
                          child: Icon(
                            Icons.flashlight_on,
                            size: 30,
                            color: ColorConstant.blackColor,
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
