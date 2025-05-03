import 'package:tsth_app/features/validation/domain/entities/validation.dart';
import 'package:tsth_app/features/validation/domain/entities/validation_entity.dart';

abstract class ValidationRepository {
  Future<List<Validation>> getValidations();
  Future<Validation> getDetailValidations(int id);
  Future<void> saveValidation(ValidationEntity validation);
  Future<void> updateValidation(int id, ValidationEntity validation);
  Future<void> exportValidationExcel();
}
