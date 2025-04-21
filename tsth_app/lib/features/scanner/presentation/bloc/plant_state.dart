import 'package:tsth_app/features/scanner/domain/entities/plant.dart';

abstract class PlantState {}

class PlantInitial extends PlantState {}

class PlantLoading extends PlantState {}

class PlantLoaded extends PlantState {
  final Plant plant;

  PlantLoaded(this.plant);
}

class PlantError extends PlantState {
  final String message;

  PlantError(this.message);
}
