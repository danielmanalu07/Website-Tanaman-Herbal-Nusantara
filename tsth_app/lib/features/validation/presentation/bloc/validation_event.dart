import 'package:tsth_app/features/validation/domain/entities/validation_entity.dart';

abstract class ValidationEvent {}

class LoadValidations extends ValidationEvent {}

class LoadValidationDetail extends ValidationEvent {
  final int id;

  LoadValidationDetail(this.id);
}

class ValidationRefresh extends ValidationEvent {}

class ValidationDetailRefresh extends ValidationEvent {
  final int id;

  ValidationDetailRefresh(this.id);
}

class SaveValidationEvent extends ValidationEvent {
  final ValidationEntity validation;

  SaveValidationEvent(this.validation);
}

class UpdateValidationEvent extends ValidationEvent {
  final int id;
  final ValidationEntity validation;

  UpdateValidationEvent(this.id, this.validation);
}

class ExportValidationExcelEvent extends ValidationEvent {}

class ClearExportMessageEvent extends ValidationEvent {}
