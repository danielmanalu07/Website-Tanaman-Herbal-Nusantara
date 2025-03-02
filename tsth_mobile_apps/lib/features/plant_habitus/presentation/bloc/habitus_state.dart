import 'package:tsth_mobile_apps/features/plant_habitus/domain/entities/habitus.dart';

abstract class HabitusState {}

class HabitusInitial extends HabitusState {}

class HabitusLoading extends HabitusState {}

class HabitusSuccess extends HabitusState {
  final List<Habitus> habitusList;

  HabitusSuccess(this.habitusList);
}

class HabitusError extends HabitusState {
  final String message;

  HabitusError(this.message);
}
