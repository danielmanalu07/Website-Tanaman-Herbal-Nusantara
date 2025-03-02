import 'package:tsth_mobile_apps/features/plant_habitus/domain/entities/habitus.dart';

abstract class HabitusRepository {
  Future<List<Habitus>> getHabitus();
}
