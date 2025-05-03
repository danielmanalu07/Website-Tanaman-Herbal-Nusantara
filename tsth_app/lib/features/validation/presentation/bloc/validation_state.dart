import 'package:tsth_app/features/validation/domain/entities/validation.dart';

abstract class ValidationState {}

//All Validation
class ValidationInitial extends ValidationState {}

class ValidationLoading extends ValidationState {}

class ValidationLoaded extends ValidationState {
  final List<Validation> validations;
  final bool isExporting;
  final bool isExportSuccess;
  final String? exportMessage;

  ValidationLoaded(
    this.validations, {
    this.isExporting = false,
    this.isExportSuccess = false,
    this.exportMessage,
  });

  ValidationLoaded copyWith({
    List<Validation>? validations,
    bool? isExporting,
    bool? isExportSuccess,
    String? exportMessage,
  }) {
    return ValidationLoaded(
      validations ?? this.validations,
      isExporting: isExporting ?? this.isExporting,
      isExportSuccess: isExportSuccess ?? this.isExportSuccess,
      exportMessage: exportMessage,
    );
  }

  List<Object?> get props => [
    validations,
    isExporting,
    isExportSuccess,
    exportMessage,
  ];
}

class ValidationError extends ValidationState {
  final String message;
  ValidationError(this.message);
}

//Detail Validation
class ValidationDetailLoading extends ValidationState {}

class ValidationDetailLoaded extends ValidationState {
  final Validation validation;

  ValidationDetailLoaded(this.validation);
}

class ValidationSuccess extends ValidationState {}

class ValidationFailure extends ValidationState {
  final String message;

  ValidationFailure(this.message);
}

//Update Validation
class ValidationUpdating extends ValidationState {}

class ValidationUpdateSuccess extends ValidationState {}

class ValidationUpdateFailure extends ValidationState {
  final String message;

  ValidationUpdateFailure(this.message);
}
