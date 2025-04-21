import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:tsth_app/features/validation/domain/usecases/SaveValidationUseCase%20.dart';
import 'package:tsth_app/features/validation/domain/usecases/get_detail_validation.dart';
import 'package:tsth_app/features/validation/domain/usecases/get_validations.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_event.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_state.dart';

class ValidationBloc extends Bloc<ValidationEvent, ValidationState> {
  final GetValidations getValidations;
  final GetDetailValidation getDetailValidation;
  final Savevalidationusecase savevalidationusecase;

  ValidationBloc(
    this.getValidations,
    this.getDetailValidation,
    this.savevalidationusecase,
  ) : super(ValidationInitial()) {
    on<LoadValidations>((event, emit) async {
      emit(ValidationLoading());
      try {
        final validations = await getValidations();
        emit(ValidationLoaded(validations));
      } catch (e) {
        emit(ValidationError(e.toString()));
      }
    });

    on<ValidationRefresh>((event, emit) async {
      try {
        final validations = await getValidations();
        emit(ValidationLoaded(validations));
      } catch (e) {
        emit(ValidationError(e.toString()));
      }
    });

    on<LoadValidationDetail>((event, emit) async {
      emit(ValidationLoading());
      try {
        final validation = await getDetailValidation(event.id);
        emit(ValidationDetailLoaded(validation));
      } catch (e) {
        emit(ValidationError(e.toString()));
      }
    });

    on<ValidationDetailRefresh>((event, emit) async {
      try {
        final validation = await getDetailValidation(event.id);
        emit(ValidationDetailLoaded(validation));
      } catch (e) {
        emit(ValidationError(e.toString()));
      }
    });

    on<SaveValidationEvent>((event, emit) async {
      emit(ValidationLoading());
      try {
        await savevalidationusecase(event.validation);
        emit(ValidationSuccess());
      } catch (e) {
        emit(ValidationFailure(e.toString()));
      }
    });
  }
}
