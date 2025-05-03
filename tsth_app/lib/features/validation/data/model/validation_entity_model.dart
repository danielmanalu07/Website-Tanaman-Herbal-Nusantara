import 'package:tsth_app/features/validation/domain/entities/validation.dart';
import 'package:tsth_app/features/validation/domain/entities/validation_entity.dart';

class ValidationEntityModel extends ValidationEntity {
  ValidationEntityModel({
    required super.id,
    required super.dateValidation,
    required super.condition,
    required super.description,
    required super.imagePaths,
    required super.plantId,
    required super.images,
  });

  factory ValidationEntityModel.fromValidation(Validation validation) {
    return ValidationEntityModel(
      id: validation.id,
      dateValidation: validation.date,
      condition: validation.condition,
      description: validation.description,
      imagePaths: validation.images.map((img) => img.imagePath).toList(),
      plantId: validation.plant?.id.toString() ?? '',
      images: validation.images,
    );
  }
}
