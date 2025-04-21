import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:tsth_app/features/scanner/domain/usecases/GetPlantByIdUseCase.dart';
import 'package:tsth_app/features/scanner/presentation/bloc/plant_event.dart';
import 'package:tsth_app/features/scanner/presentation/bloc/plant_state.dart';

class PlantBloc extends Bloc<PlantEvent, PlantState> {
  final Getplantbyidusecase getPlantByIdUseCase;

  PlantBloc(this.getPlantByIdUseCase) : super(PlantInitial()) {
    on<FetchPlantEvent>((event, emit) async {
      emit(PlantLoading());
      try {
        final plant = await getPlantByIdUseCase(event.id);
        emit(PlantLoaded(plant));
      } catch (e) {
        emit(PlantError("Gagal mengambil data tanaman: ${e.toString()}"));
      }
    });
  }
}
