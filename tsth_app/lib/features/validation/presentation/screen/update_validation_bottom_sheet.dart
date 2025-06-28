import 'dart:io';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:intl/intl.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'package:tsth_app/core/widgets/custom_button.dart';
import 'package:tsth_app/core/widgets/custom_form.dart';
import 'package:tsth_app/core/widgets/custom_snackbar.dart';
import 'package:tsth_app/features/validation/domain/entities/validation.dart';
import 'package:tsth_app/features/validation/domain/entities/validation_entity.dart';
import 'package:tsth_app/features/validation/domain/entities/validation_image.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_bloc.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_event.dart';
import 'package:tsth_app/features/validation/presentation/widget/custom_date_picker.dart';
import 'package:tsth_app/features/validation/presentation/widget/custom_dropdown.dart';
import 'package:tsth_app/features/validation/presentation/widget/custom_upload_button.dart';

class UpdateValidationBottomSheet extends StatefulWidget {
  final Validation initialValidation;
  const UpdateValidationBottomSheet({
    super.key,
    required this.initialValidation,
  });

  @override
  State<UpdateValidationBottomSheet> createState() =>
      _UpdateValidationBottomSheetState();
}

class _UpdateValidationBottomSheetState
    extends State<UpdateValidationBottomSheet> {
  late TextEditingController _dateController;
  late TextEditingController _descriptionController;
  String? _selectedCondition;
  final List<String> _conditions = ['Healthy', 'Unhealthy', 'Needs Attention'];
  List<File> _newImages = [];
  List<int> _deletedImageIds = [];
  List<ValidationImage> _remainingImages = [];

  @override
  void initState() {
    super.initState();
    final parsedDate = DateFormat(
      "dd MMMM yyyy",
    ).parse(widget.initialValidation.date);
    final formattedDate = DateFormat('yyyy-MM-dd').format(parsedDate);

    _dateController = TextEditingController(text: formattedDate);
    _descriptionController = TextEditingController(
      text: widget.initialValidation.description,
    );
    _selectedCondition = widget.initialValidation.condition;
    _remainingImages = List.from(widget.initialValidation.images);
  }

  @override
  void dispose() {
    _dateController.dispose();
    _descriptionController.dispose();
    super.dispose();
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
      _newImages.addAll(images);
    });
  }

  void _deleteImage(int imageId) {
    if (_remainingImages.length <= 1) {
      CustomSnackbar.alert(context, "Image minimum already 1", true);
      return;
    }

    if (!_deletedImageIds.contains(imageId)) {
      setState(() {
        _remainingImages.removeWhere((img) => img.id == imageId);
        _deletedImageIds.add(imageId);
      });
    }
  }

  void _submitUpdate() {
    if (_selectedCondition == null ||
        _dateController.text.isEmpty ||
        _descriptionController.text.isEmpty) {
      CustomSnackbar.alert(context, 'Please Fill all required fields', true);
      return;
    }

    final validationEntity = ValidationEntity(
      id: widget.initialValidation.id,
      dateValidation: _dateController.text,
      condition: _selectedCondition!,
      description: _descriptionController.text,
      imagePaths: _newImages.map((file) => file.path).toList(),
      plantId: widget.initialValidation.plant?.id.toString() ?? '',
      images: _remainingImages,
      deletedImageIds: _deletedImageIds,
    );

    // Show loading indicator
    showDialog(
      context: context,
      barrierDismissible: false,
      builder:
          (context) => const Center(
            child: CircularProgressIndicator(color: ColorConstant.whiteColor),
          ),
    );

    // Dispatch update event
    context.read<ValidationBloc>().add(
      UpdateValidationEvent(widget.initialValidation.id, validationEntity),
    );

    Navigator.of(context).pop();
    Navigator.of(context).pop();
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(16.0),
      decoration: const BoxDecoration(
        color: ColorConstant.whiteColor,
        borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
      ),
      child: SingleChildScrollView(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Center(
              child: Text(
                'Update Validation',
                style: TextStyle(
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                  color: ColorConstant.greenColor,
                ),
              ),
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
            CustomForm(
              label: 'Description',
              controller: _descriptionController,
              isPassword: false,
              keyboardType: TextInputType.multiline,
              radius: 12,
              maxLines: 3,
            ),
            const SizedBox(height: 16),
            Text(
              'Current Images (Tap To Delete)',
              style: TextStyle(color: Colors.grey[600], fontSize: 14),
            ),
            const SizedBox(height: 16),
            Wrap(
              spacing: 8,
              runSpacing: 8,
              children:
                  _remainingImages
                      .map(
                        (image) => GestureDetector(
                          onTap: () => _deleteImage(image.id),
                          child: Stack(
                            children: [
                              ClipRRect(
                                borderRadius: BorderRadius.circular(8),
                                child: Image.network(
                                  image.imagePath,
                                  width: 80,
                                  height: 80,
                                  fit: BoxFit.cover,
                                  errorBuilder:
                                      (context, error, stackTrace) => Container(
                                        width: 80,
                                        height: 80,
                                        color: Colors.grey[200],
                                        child: const Icon(Icons.broken_image),
                                      ),
                                ),
                              ),
                              Positioned(
                                right: 0,
                                child: Container(
                                  decoration: const BoxDecoration(
                                    color: Colors.red,
                                    shape: BoxShape.circle,
                                  ),
                                  child: const Icon(
                                    Icons.close,
                                    color: Colors.white,
                                    size: 16,
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      )
                      .toList(),
            ),
            const SizedBox(height: 16),
            CustomUploadButton(
              text: 'Add New Images',
              onImagesSelected: _uploadImage,
            ),
            const SizedBox(height: 24),
            Row(
              children: [
                Expanded(
                  child: CustomButton(
                    text: 'CANCEL',
                    onPressed: () => Navigator.of(context).pop(),
                    textColor: ColorConstant.greenColor,
                    bgColor: Colors.white,
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(width: 16),
                Expanded(
                  child: CustomButton(
                    text: 'UPDATE',
                    onPressed: _submitUpdate,
                    textColor: Colors.white,
                    bgColor: ColorConstant.greenColor,
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ],
            ),
            const SizedBox(height: 16),
          ],
        ),
      ),
    );
  }
}
