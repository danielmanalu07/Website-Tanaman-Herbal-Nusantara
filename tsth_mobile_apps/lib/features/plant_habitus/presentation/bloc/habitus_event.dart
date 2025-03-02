abstract class HabitusEvent {}

class LoadHabitus extends HabitusEvent {}

class RefreshHabitusEvent extends HabitusEvent {
  List<Object?> get props => [];
}
