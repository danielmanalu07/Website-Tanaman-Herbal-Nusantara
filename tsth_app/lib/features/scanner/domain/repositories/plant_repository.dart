import 'package:tsth_app/features/scanner/domain/entities/plant.dart';

abstract class PlantRepository {
  Future<Plant> getPlantById(int id);
}
