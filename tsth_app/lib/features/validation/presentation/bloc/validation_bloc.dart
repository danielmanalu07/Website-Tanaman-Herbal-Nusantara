import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:tsth_app/features/validation/domain/usecases/SaveValidationUseCase%20.dart';
import 'package:tsth_app/features/validation/domain/usecases/export_validation_excel_UseCase.dart';
import 'package:tsth_app/features/validation/domain/usecases/get_detail_validation.dart';
import 'package:tsth_app/features/validation/domain/usecases/get_validations.dart';
import 'package:tsth_app/features/validation/domain/usecases/updateValidationUseCase.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_event.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_state.dart';

class ValidationBloc extends Bloc<ValidationEvent, ValidationState> {
  final GetValidations getValidations;
  final GetDetailValidation getDetailValidation;
  final Savevalidationusecase saveValidationUseCase;
  final Updatevalidationusecase _updatevalidationusecase;
  final ExportValidationExcelUsecase _exportValidationExcelUsecase;

  ValidationBloc(
    this.getValidations,
    this.getDetailValidation,
    this.saveValidationUseCase,
    this._updatevalidationusecase,
    this._exportValidationExcelUsecase,
  ) : super(ValidationInitial()) {
    on<LoadValidations>(_loadValidations);
    on<ValidationRefresh>(_loadValidations);

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
        await saveValidationUseCase(event.validation);
        emit(ValidationSuccess());
      } catch (e) {
        emit(ValidationFailure(e.toString()));
      }
    });

    on<UpdateValidationEvent>((event, emit) async {
      emit(ValidationUpdating());
      try {
        await _updatevalidationusecase(event.id, event.validation);
        emit(ValidationUpdateSuccess());
        add(LoadValidationDetail(event.id));
      } catch (e) {
        emit(ValidationUpdateFailure(e.toString()));
      }
    });

    on<ExportValidationExcelEvent>((event, emit) async {
      final currentState = state;
      if (currentState is ValidationLoaded) {
        emit(currentState.copyWith(isExporting: true));
        try {
          await _exportValidationExcelUsecase();
          emit(
            currentState.copyWith(
              isExporting: false,
              isExportSuccess: true,
              exportMessage: 'Export Successfully',
            ),
          );
        } catch (e) {
          emit(
            currentState.copyWith(
              isExporting: false,
              isExportSuccess: false,
              exportMessage: e.toString(),
            ),
          );
        }
      }
    });

    on<ClearExportMessageEvent>((event, emit) {
      if (state is ValidationLoaded) {
        emit((state as ValidationLoaded).copyWith(exportMessage: null));
      }
    });
  }

  Future<void> _loadValidations(
    ValidationEvent event,
    Emitter<ValidationState> emit,
  ) async {
    emit(ValidationLoading());
    try {
      final validations = await getValidations();
      emit(ValidationLoaded(validations));
    } catch (e) {
      emit(ValidationError(e.toString()));
    }
  }
}
