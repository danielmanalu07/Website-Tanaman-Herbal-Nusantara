import 'package:tsth_app/features/validation/domain/entities/validation.dart';
import 'package:tsth_app/features/validation/domain/repositories/validation_repository.dart';

class GetDetailValidation {
  final ValidationRepository validationRepository;

  GetDetailValidation({required this.validationRepository});

  Future<Validation> call(int id) async {
    return await validationRepository.getDetailValidations(id);
  }
}
