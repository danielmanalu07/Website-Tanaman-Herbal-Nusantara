import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/domain/usecases/get_all_habitus_usecase.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/presentation/bloc/habitus_event.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/presentation/bloc/habitus_state.dart';

class HabitusBloc extends Bloc<HabitusEvent, HabitusState> {
  final GetAllHabitusUsecase getAllHabitusUsecase;

  HabitusBloc(this.getAllHabitusUsecase) : super(HabitusInitial()) {
    on<LoadHabitus>((event, emit) async {
      emit(HabitusLoading());
      try {
        final habitus = await getAllHabitusUsecase();
        emit(HabitusSuccess(habitus));
      } catch (e) {
        emit(HabitusError(e.toString()));
      }
    });

    on<RefreshHabitusEvent>((event, emit) async {
      emit(HabitusLoading());
      try {
        final habitus = await getAllHabitusUsecase();
        emit(HabitusSuccess(habitus));
      } catch (e) {
        emit(HabitusError(e.toString()));
      }
    });
  }
}
