import 'package:tsth_app/features/scanner/domain/entities/plant.dart';
import 'package:tsth_app/features/scanner/domain/repositories/plant_repository.dart';

class Getplantbyidusecase {
  final PlantRepository plantRepository;

  Getplantbyidusecase(this.plantRepository);

  Future<Plant> call(int id) {
    return plantRepository.getPlantById(id);
  }
}
