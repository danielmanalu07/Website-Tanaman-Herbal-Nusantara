import 'package:tsth_app/features/validation/data/dataSource/validation_remote_dataSource.dart';
import 'package:tsth_app/features/validation/domain/entities/validation.dart';
import 'package:tsth_app/features/validation/domain/entities/validation_entity.dart';
import 'package:tsth_app/features/validation/domain/repositories/validation_repository.dart';

class ValidationRepositoryImpl implements ValidationRepository {
  final ValidationRemoteDatasource validationRemoteDatasource;

  ValidationRepositoryImpl({required this.validationRemoteDatasource});

  // @override
  // Future<Validation> getDetailValidations(int id) {
  //   // return localDatasource.getDetailValidations(id);
  // }

  @override
  Future<void> saveValidation(ValidationEntity validation) async {
    return await validationRemoteDatasource.saveValidation(validation);
  }

  @override
  Future<List<Validation>> getValidations() async {
    return await validationRemoteDatasource.get_all_validated();
  }

  @override
  Future<Validation> getDetailValidations(int id) async {
    return await validationRemoteDatasource.get_detail_validated(id);
  }
}
