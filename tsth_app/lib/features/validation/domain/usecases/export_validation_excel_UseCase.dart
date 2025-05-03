import 'package:tsth_app/features/validation/domain/repositories/validation_repository.dart';

class ExportValidationExcelUsecase {
  final ValidationRepository _validationRepository;

  ExportValidationExcelUsecase(this._validationRepository);

  Future<void> call() async {
    return await _validationRepository.exportValidationExcel();
  }
}
