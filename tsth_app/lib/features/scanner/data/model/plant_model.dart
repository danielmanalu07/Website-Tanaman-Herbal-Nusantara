import 'package:tsth_app/features/scanner/data/model/habitus_model.dart';
import 'package:tsth_app/features/scanner/domain/entities/plant.dart';

class PlantModel extends Plant {
  PlantModel({
    required super.id,
    required super.name,
    required super.latinName,
    required super.advantage,
    required super.ecology,
    required super.endemicInformation,
    required super.status,
    required super.habitus,
    required super.qrcode,
  });

  factory PlantModel.fromJson(Map<String, dynamic> json) {
    return PlantModel(
      id: json['id'],
      name: json['name'],
      latinName: json['latin_name'],
      advantage: json['advantage'],
      ecology: json['ecology'],
      endemicInformation: json['endemic_information'],
      status: json['status'],
      habitus: HabitusModel.fromJson(json['habitus']),
      qrcode: json['qrcode'],
    );
  }
}
