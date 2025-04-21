import 'package:tsth_app/features/scanner/domain/entities/habitus.dart';

class HabitusModel extends Habitus {
  HabitusModel({required super.id, required super.name});

  factory HabitusModel.fromJson(Map<String, dynamic> json) {
    return HabitusModel(id: json['id'], name: json['name']);
  }

  Map<String, dynamic> toJson() {
    return {'id': id, 'name': name};
  }
}
