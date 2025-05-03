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
import 'package:tsth_app/features/validation/presentation/widget/ScannerOverlayPainter.dart';
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
  bool _isProcessing = false;
  String? _lastScannedCode;
  DateTime? _lastScanTime;

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
    _mobileScannerController.dispose();
    super.dispose();
  }

  Future<void> _processQRCode(String? barcodeValue) async {
    if (barcodeValue == null || barcodeValue.isEmpty) {
      showErrorFlushbar(context, 'QR/Barcode tidak terbaca.');
      return;
    }

    // Prevent processing the same code multiple times
    if (_lastScannedCode == barcodeValue) {
      final now = DateTime.now();
      if (_lastScanTime != null &&
          now.difference(_lastScanTime!) < const Duration(seconds: 2)) {
        return;
      }
    }

    _lastScannedCode = barcodeValue;
    _lastScanTime = DateTime.now();

    setState(() => _isProcessing = true);

    try {
      final uri = Uri.tryParse(barcodeValue);
      int? id;

      if (uri != null && uri.pathSegments.isNotEmpty) {
        // Handle URL format QR codes
        final lastSegment = uri.pathSegments.last;
        id = int.tryParse(lastSegment);
      } else {
        // Handle plain number QR codes
        id = int.tryParse(barcodeValue.trim());
      }

      debugPrint('Scan Result: $barcodeValue, Extracted ID: $id');

      if (id != null) {
        context.read<PlantBloc>().add(FetchPlantEvent(id));
      } else {
        showErrorFlushbar(context, 'Format QR tidak valid.');
        setState(() => _isProcessing = false);
      }
    } catch (e) {
      debugPrint('Error processing QR: $e');
      showErrorFlushbar(context, 'Terjadi kesalahan saat membaca QR code.');
      setState(() => _isProcessing = false);
    }
  }

  Future<void> _onGalleryButtonPressed() async {
    if (_isProcessing) return;

    final ImagePicker picker = ImagePicker();
    final XFile? pickedFile = await picker.pickImage(
      source: ImageSource.gallery,
    );

    if (pickedFile != null) {
      setState(() => _isProcessing = true);

      try {
        final BarcodeCapture? result = await _mobileScannerController
            .analyzeImage(pickedFile.path);

        if (result != null && result.barcodes.isNotEmpty) {
          await _processQRCode(result.barcodes.first.rawValue);
        } else {
          showErrorFlushbar(context, 'QR/Barcode tidak ditemukan.');
          setState(() => _isProcessing = false);
        }
      } catch (e) {
        debugPrint('Error scanning image: $e');
        showErrorFlushbar(context, 'Gagal memindai gambar.');
        setState(() => _isProcessing = false);
      }
    }
  }

  void _onDetect(BarcodeCapture capture) {
    debugPrint('Detected ${capture.barcodes.length} barcodes');

    if (_isProcessing) return;

    if (capture.barcodes.isNotEmpty) {
      final barcode = capture.barcodes.first;
      debugPrint('Scanned QR code: ${barcode.rawValue}');
      _processQRCode(barcode.rawValue);
    }
  }

  @override
  Widget build(BuildContext context) {
    return WillPopScope(
      onWillPop: () async {
        context.pop();
        return false;
      },
      child: Scaffold(
        backgroundColor: ColorConstant.backgroundColor,
        appBar: AppBar(
          backgroundColor: Colors.transparent,
          elevation: 0,
          leading: IconButton(
            icon: const Icon(Icons.arrow_back, color: ColorConstant.greenColor),
            onPressed: () {
              context.pop();
            },
          ),
          title: const Text(
            'Scan QR Tanaman',
            style: TextStyle(color: ColorConstant.greenColor),
          ),
        ),
        body: BlocListener<PlantBloc, PlantState>(
          listener: (context, state) {
            if (state is PlantLoaded) {
              setState(() => _isProcessing = false);
              context.go(InitialRoute.validationScreen);
            } else if (state is PlantError) {
              setState(() => _isProcessing = false);
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
                        const SizedBox(height: 16),
                        ElevatedButton(
                          onPressed: () => setState(() {}), // Retry
                          child: const Text('Coba Lagi'),
                        ),
                      ],
                    ),
                  );
                },
              ),
              // Scanner overlay with animation
              CustomPaint(
                painter: ScannerOverlayPainter(boxSize: 250),
                child: Center(
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
              ),
              if (_isProcessing)
                Container(
                  color: Colors.black.withOpacity(0.5),
                  child: const Center(
                    child: CircularProgressIndicator(color: Colors.white),
                  ),
                ),
              // Gallery and Flash buttons
              Align(
                alignment: Alignment.bottomCenter,
                child: Padding(
                  padding: const EdgeInsets.only(bottom: 80),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      IconButton(
                        onPressed:
                            _isProcessing ? null : _onGalleryButtonPressed,
                        icon: CircleAvatar(
                          radius: 30,
                          backgroundColor: ColorConstant.whiteColor,
                          child: Icon(
                            Icons.photo_library,
                            size: 30,
                            color:
                                _isProcessing
                                    ? Colors.grey
                                    : ColorConstant.blackColor,
                          ),
                        ),
                      ),
                      const SizedBox(width: 20),
                      IconButton(
                        onPressed:
                            _isProcessing
                                ? null
                                : () => _mobileScannerController.toggleTorch(),
                        icon: CircleAvatar(
                          radius: 30,
                          backgroundColor: ColorConstant.whiteColor,
                          child: Icon(
                            Icons.flashlight_on,
                            size: 30,
                            color:
                                _isProcessing
                                    ? Colors.grey
                                    : ColorConstant.blackColor,
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
