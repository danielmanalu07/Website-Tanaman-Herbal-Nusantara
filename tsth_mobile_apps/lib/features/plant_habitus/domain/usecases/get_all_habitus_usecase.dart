import 'package:tsth_mobile_apps/features/plant_habitus/domain/entities/habitus.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/domain/repositories/habitus_repository.dart';

class GetAllHabitusUsecase {
  final HabitusRepository habitusRepository;

  GetAllHabitusUsecase(this.habitusRepository);

  Future<List<Habitus>> call() async {
    return await habitusRepository.getHabitus();
  }
}
