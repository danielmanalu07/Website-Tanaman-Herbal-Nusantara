import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'dart:io';

class CustomUploadButton extends StatefulWidget {
  final String text;
  final Function(List<File>)
  onImagesSelected; // Callback to pass selected images to parent

  const CustomUploadButton({
    super.key,
    required this.text,
    required this.onImagesSelected,
  });

  @override
  State<CustomUploadButton> createState() => _CustomUploadButtonState();
}

class _CustomUploadButtonState extends State<CustomUploadButton> {
  final ImagePicker _picker = ImagePicker();
  List<File> _selectedImages = []; // List to store selected images

  // Function to show dialog for choosing camera or gallery
  Future<void> _showImageSourceDialog() async {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: const Text('Select Image Source'),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.pop(context);
                _pickImage(ImageSource.camera);
              },
              child: const Text('Camera'),
            ),
            TextButton(
              onPressed: () {
                Navigator.pop(context);
                _pickImage(ImageSource.gallery);
              },
              child: const Text('Gallery'),
            ),
          ],
        );
      },
    );
  }

  // Function to pick images
  Future<void> _pickImage(ImageSource source) async {
    if (source == ImageSource.camera) {
      // Pick a single image from the camera
      final XFile? image = await _picker.pickImage(source: source);
      if (image != null) {
        setState(() {
          _selectedImages.add(File(image.path));
        });
        widget.onImagesSelected(_selectedImages); // Notify parent
      }
    } else {
      // Pick multiple images from the gallery
      final List<XFile> images = await _picker.pickMultiImage();
      if (images.isNotEmpty) {
        setState(() {
          _selectedImages.addAll(images.map((xFile) => File(xFile.path)));
        });
        widget.onImagesSelected(_selectedImages); // Notify parent
      }
    }
  }

  // Function to remove an image from the list
  void _removeImage(int index) {
    setState(() {
      _selectedImages.removeAt(index);
    });
    widget.onImagesSelected(_selectedImages); // Notify parent
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        // Upload Button
        OutlinedButton(
          onPressed: _showImageSourceDialog,
          style: OutlinedButton.styleFrom(
            side: BorderSide(color: ColorConstant.greenColor),
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
            padding: const EdgeInsets.symmetric(vertical: 12),
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(Icons.upload, color: ColorConstant.greenColor),
              const SizedBox(width: 8),
              Text(
                widget.text,
                style: TextStyle(
                  color: ColorConstant.greenColor,
                  fontSize: 16,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ],
          ),
        ),
        const SizedBox(height: 16),
        // Image Preview
        if (_selectedImages.isNotEmpty)
          SizedBox(
            height: 100,
            child: ListView.builder(
              scrollDirection: Axis.horizontal,
              itemCount: _selectedImages.length,
              itemBuilder: (context, index) {
                return Padding(
                  padding: const EdgeInsets.only(right: 8.0),
                  child: Stack(
                    children: [
                      // Image Preview
                      ClipRRect(
                        borderRadius: BorderRadius.circular(8),
                        child: Image.file(
                          _selectedImages[index],
                          width: 100,
                          height: 100,
                          fit: BoxFit.cover,
                        ),
                      ),
                      // Remove Button
                      Positioned(
                        top: 0,
                        right: 0,
                        child: GestureDetector(
                          onTap: () => _removeImage(index),
                          child: Container(
                            decoration: const BoxDecoration(
                              color: Colors.red,
                              shape: BoxShape.circle,
                            ),
                            child: const Icon(
                              Icons.close,
                              color: Colors.white,
                              size: 20,
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                );
              },
            ),
          ),
      ],
    );
  }
}
