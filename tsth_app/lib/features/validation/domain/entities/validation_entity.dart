import 'package:tsth_app/features/validation/domain/entities/validation_image.dart';

class ValidationEntity {
  final int id;
  final String plantId;
  final String dateValidation;
  final String condition;
  final String description;
  final List<String> imagePaths;
  final List<ValidationImage> images;
  final List<int>? deletedImageIds;

  ValidationEntity({
    required this.id,
    required this.dateValidation,
    required this.condition,
    required this.description,
    required this.imagePaths,
    required this.plantId,
    required this.images,
    this.deletedImageIds,
  });
}
