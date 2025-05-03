import 'package:tsth_app/features/validation/domain/entities/validation_entity.dart';
import 'package:tsth_app/features/validation/domain/repositories/validation_repository.dart';

class Updatevalidationusecase {
  final ValidationRepository _validationRepository;

  Updatevalidationusecase(this._validationRepository);

  Future<void> call(int id, ValidationEntity validation) async {
    await _validationRepository.updateValidation(id, validation);
  }
}
