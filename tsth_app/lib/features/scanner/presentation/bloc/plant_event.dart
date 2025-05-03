abstract class PlantEvent {}

class FetchPlantEvent extends PlantEvent {
  final int id;

  FetchPlantEvent(this.id);
}
