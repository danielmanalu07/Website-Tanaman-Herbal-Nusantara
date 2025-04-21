import 'package:tsth_app/features/validation/domain/entities/validation_image.dart';

class ValidationImageModel extends ValidationImage {
  ValidationImageModel({required super.id, required super.imagePath});

  factory ValidationImageModel.fromJson(Map<String, dynamic> json) {
    return ValidationImageModel(id: json['id'], imagePath: json['image_path']);
  }

  Map<String, dynamic> toJson() {
    return {'id': id, 'image_path': imagePath};
  }
}
