import 'package:tsth_app/features/validation/domain/entities/validation_entity.dart';
import 'package:tsth_app/features/validation/domain/repositories/validation_repository.dart';

class Savevalidationusecase {
  final ValidationRepository repository;

  Savevalidationusecase(this.repository);

  Future<void> call(ValidationEntity validation) async {
    await repository.saveValidation(validation);
  }
}
