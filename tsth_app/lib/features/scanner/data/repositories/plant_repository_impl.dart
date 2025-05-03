import 'package:tsth_app/features/scanner/data/dataSource/plant_remote_data_source.dart';
import 'package:tsth_app/features/scanner/domain/entities/plant.dart';
import 'package:tsth_app/features/scanner/domain/repositories/plant_repository.dart';

class PlantRepositoryImpl implements PlantRepository {
  final PlantRemoteDataSource plantRemoteDataSource;

  PlantRepositoryImpl(this.plantRemoteDataSource);
  @override
  Future<Plant> getPlantById(int id) async {
    return plantRemoteDataSource.getPlantById(id);
  }
}
