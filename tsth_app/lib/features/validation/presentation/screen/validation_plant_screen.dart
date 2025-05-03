import 'dart:io';
import 'package:another_flushbar/flushbar.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:go_router/go_router.dart';
import 'package:intl/intl.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'package:tsth_app/core/widgets/custom_button.dart';
import 'package:tsth_app/core/widgets/custom_form.dart';
import 'package:tsth_app/features/scanner/presentation/bloc/plant_bloc.dart';
import 'package:tsth_app/features/scanner/presentation/bloc/plant_state.dart';
import 'package:tsth_app/features/validation/domain/entities/validation_entity.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_bloc.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_event.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_state.dart';
import 'package:tsth_app/features/validation/presentation/widget/custom_date_picker.dart';
import 'package:tsth_app/features/validation/presentation/widget/custom_dropdown.dart';
import 'package:tsth_app/features/validation/presentation/widget/custom_upload_button.dart';
import 'package:tsth_app/routes/initial_route.dart';

class ValidationPlantScreen extends StatefulWidget {
  const ValidationPlantScreen({super.key});

  @override
  State<ValidationPlantScreen> createState() => _ValidationPlantScreenState();
}

class _ValidationPlantScreenState extends State<ValidationPlantScreen> {
  final TextEditingController _plantNameController = TextEditingController();
  final TextEditingController _latinNameController = TextEditingController();
  final TextEditingController _habitusController = TextEditingController();
  final TextEditingController _dateController = TextEditingController();
  final TextEditingController _suggestionController = TextEditingController();

  String? _selectedCondition;
  final List<String> _conditions = ['Healthy', 'Unhealthy', 'Needs Attention'];

  List<File> _uploadedImages = [];

  @override
  void initState() {
    super.initState();
    _dateController.text = DateFormat('yyyy-MM-dd').format(DateTime.now());
  }

  Future<void> _selectDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: DateTime.now(),
      firstDate: DateTime(2000),
      lastDate: DateTime(2101),
    );
    if (picked != null) {
      setState(() {
        _dateController.text = DateFormat('yyyy-MM-dd').format(picked);
      });
    }
  }

  void _uploadImage(List<File> images) {
    setState(() {
      _uploadedImages = images;
    });
    print("Selected images: ${_uploadedImages.length}");
  }

  void _submitForm() {
    if (_selectedCondition == null ||
        _uploadedImages.isEmpty ||
        _suggestionController.text.isEmpty) {
      Flushbar(
        message:
            'Please select a condition, upload at least one image, and ensure date is filled',
        duration: const Duration(seconds: 3),
        backgroundColor: Colors.red,
        flushbarPosition: FlushbarPosition.TOP,
      ).show(context);
      return;
    }

    final plantState = context.read<PlantBloc>().state;
    if (plantState is PlantLoaded) {
      final validation = ValidationEntity(
        id: 0,
        dateValidation: _dateController.text,
        condition: _selectedCondition!,
        description:
            _suggestionController.text.isEmpty
                ? ''
                : _suggestionController.text,
        imagePaths: _uploadedImages.map((file) => file.path).toList(),
        plantId: plantState.plant.id.toString(),
        images: [],
      );

      print('Submitting validation: $validation');
      context.read<ValidationBloc>().add(SaveValidationEvent(validation));
    } else {
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(const SnackBar(content: Text('Plant data not loaded')));
    }
  }

  @override
  void dispose() {
    _plantNameController.dispose();
    _latinNameController.dispose();
    _habitusController.dispose();
    _dateController.dispose();
    _suggestionController.dispose();
    super.dispose();
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
          title: const Text(
            'VALIDATION PLANT',
            style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
          ),
          centerTitle: true,
          backgroundColor: Colors.transparent,
          elevation: 0,
          leading: IconButton(
            icon: const Icon(Icons.arrow_back, color: Colors.black),
            onPressed: () {
              if (Navigator.of(context).canPop()) {
                Navigator.of(context).pop();
              } else {
                context.go(InitialRoute.homeScreen);
              }
            },
          ),
        ),
        body: SingleChildScrollView(
          padding: const EdgeInsets.all(16.0),
          child: BlocListener<ValidationBloc, ValidationState>(
            listener: (context, state) {
              if (state is ValidationSuccess) {
                showDialog(
                  context: context,
                  barrierDismissible: false,
                  builder:
                      (context) => const Center(
                        child: CircularProgressIndicator(
                          color: ColorConstant.whiteColor,
                        ),
                      ),
                );
                Future.delayed(const Duration(seconds: 1), () {
                  Navigator.of(context).pop();
                  Flushbar(
                    message: 'Validation saved successfully',
                    duration: const Duration(seconds: 3),
                    backgroundColor: Colors.green,
                    flushbarPosition: FlushbarPosition.TOP,
                  ).show(context);
                });

                Future.delayed(const Duration(seconds: 2), () {
                  context.go(InitialRoute.listValidationScreen);
                });
              } else if (state is ValidationError) {
                Flushbar(
                  message: 'Error: ${state.message}',
                  duration: const Duration(seconds: 3),
                  backgroundColor: Colors.red,
                  flushbarPosition: FlushbarPosition.TOP,
                ).show(context);
              }
            },
            child: BlocBuilder<PlantBloc, PlantState>(
              builder: (context, state) {
                if (state is PlantLoading) {
                  return const Center(child: CircularProgressIndicator());
                } else if (state is PlantLoaded) {
                  final plant = state.plant;

                  _plantNameController.text = plant.name;
                  _latinNameController.text = plant.latinName;
                  _habitusController.text = plant.habitus.name;
                  return Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      CustomForm(
                        label: 'Plant Name',
                        controller: _plantNameController,
                        isPassword: false,
                        keyboardType: TextInputType.text,
                        readOnly: true,
                        radius: 12,
                      ),
                      const SizedBox(height: 16),
                      CustomForm(
                        label: 'Latin Name',
                        controller: _latinNameController,
                        isPassword: false,
                        keyboardType: TextInputType.text,
                        radius: 12,
                        readOnly: true,
                      ),
                      const SizedBox(height: 16),
                      CustomForm(
                        label: 'Habitus',
                        controller: _habitusController,
                        isPassword: false,
                        keyboardType: TextInputType.text,
                        radius: 12,
                        readOnly: true,
                      ),
                      const SizedBox(height: 16),
                      CustomDatePicker(
                        label: 'Date',
                        controller: _dateController,
                        onTap: () => _selectDate(context),
                      ),
                      const SizedBox(height: 16),
                      CustomDropdown(
                        label: 'Plant Condition',
                        value: _selectedCondition,
                        items: _conditions,
                        onChanged: (value) {
                          setState(() {
                            _selectedCondition = value;
                          });
                        },
                      ),
                      const SizedBox(height: 16),
                      CustomUploadButton(
                        text: 'Upload Image',
                        onImagesSelected: _uploadImage,
                      ),
                      const SizedBox(height: 16),
                      CustomForm(
                        label: 'Suggestion/Description',
                        controller: _suggestionController,
                        isPassword: false,
                        keyboardType: TextInputType.multiline,
                        radius: 12,
                        maxLines: 5,
                      ),
                      const SizedBox(height: 16),
                      CustomButton(
                        text: 'SUBMIT',
                        onPressed: _submitForm,
                        textColor: Colors.white,
                        bgColor: ColorConstant.greenColor,
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                      ),
                    ],
                  );
                } else if (state is PlantError) {
                  return Text(
                    state.message,
                    style: const TextStyle(color: Colors.red),
                  );
                }
                return const SizedBox();
              },
            ),
          ),
        ),
      ),
    );
  }
}
