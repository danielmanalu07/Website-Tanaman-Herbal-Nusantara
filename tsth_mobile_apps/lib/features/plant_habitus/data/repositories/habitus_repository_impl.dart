import 'package:tsth_mobile_apps/features/plant_habitus/data/datasources/habitus_remote_data_source.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/domain/entities/habitus.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/domain/repositories/habitus_repository.dart';

class HabitusRepositoryImpl implements HabitusRepository {
  final HabitusRemoteDataSource habitusRemoteDataSource;

  HabitusRepositoryImpl(this.habitusRemoteDataSource);

  @override
  Future<List<Habitus>> getHabitus() async {
    final habitusModels = await habitusRemoteDataSource.getHabitus();
    return habitusModels;
  }
}
