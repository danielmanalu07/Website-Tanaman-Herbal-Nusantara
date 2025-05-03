import 'package:tsth_app/features/validation/data/model/plant_model.dart';
import 'package:tsth_app/features/validation/data/model/user_model.dart';
import 'package:tsth_app/features/validation/data/model/validation_image_model.dart';
import 'package:tsth_app/features/validation/domain/entities/validation.dart';

class ValidationModel extends Validation {
  ValidationModel({
    required super.id,
    required super.description,
    required super.date,
    required super.plant,
    required super.condition,
    required super.validator,
    required super.images,
    required super.createdAt,
    required super.updateAt,
  });

  factory ValidationModel.fromJson(Map<String, dynamic> json) {
    return ValidationModel(
      id: json['id'] ?? 0,
      description: json['description'] ?? '',
      condition: json['condition'] ?? '',
      date: json['date_validation'] ?? '',
      plant: json['plant'] != null ? PlantModel.fromJson(json['plant']) : null,
      validator:
          json['validator'] != null
              ? UserModel.fromJson(json['validator'])
              : null,

      images:
          json['images'] != null
              ? (json['images'] as List)
                  .map((img) => ValidationImageModel.fromJson(img))
                  .toList()
              : [],
      createdAt: json['created_at'],
      updateAt: json['updated_at'],
    );
  }
}
