abstract class PlantEvent {}

class FetchPlantEvent extends PlantEvent {
  final String id;

  FetchPlantEvent(this.id);
}
