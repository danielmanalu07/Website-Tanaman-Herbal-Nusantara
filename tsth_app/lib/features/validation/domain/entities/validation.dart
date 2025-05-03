import 'package:tsth_app/features/validation/domain/entities/plant.dart';
import 'package:tsth_app/features/validation/domain/entities/user.dart';
import 'package:tsth_app/features/validation/domain/entities/validation_image.dart';

class Validation {
  final int id;
  final String description;
  final String condition;
  final String date;
  final Plant? plant;
  final User? validator;
  final List<ValidationImage> images;
  final String createdAt;
  final String updateAt;

  Validation({
    required this.id,
    required this.description,
    required this.condition,
    required this.date,
    required this.plant,
    required this.validator,
    required this.images,
    required this.createdAt,
    required this.updateAt,
  });
}
