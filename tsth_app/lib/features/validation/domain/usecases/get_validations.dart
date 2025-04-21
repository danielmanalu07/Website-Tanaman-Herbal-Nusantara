import 'package:tsth_app/features/validation/domain/entities/validation.dart';
import 'package:tsth_app/features/validation/domain/repositories/validation_repository.dart';

class GetValidations {
  final ValidationRepository validationRepository;

  GetValidations({required this.validationRepository});

  Future<List<Validation>> call() async {
    return await validationRepository.getValidations();
  }
}
