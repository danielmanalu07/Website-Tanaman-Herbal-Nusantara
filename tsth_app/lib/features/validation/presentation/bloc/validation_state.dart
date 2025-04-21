import 'package:tsth_app/features/validation/domain/entities/validation.dart';

abstract class ValidationState {}

class ValidationInitial extends ValidationState {}

class ValidationLoading extends ValidationState {}

class ValidationLoaded extends ValidationState {
  final List<Validation> validations;
  ValidationLoaded(this.validations);
}

class ValidationError extends ValidationState {
  final String message;
  ValidationError(this.message);
}

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
