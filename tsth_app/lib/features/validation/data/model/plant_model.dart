import 'package:tsth_app/features/validation/data/model/habitus_model.dart';
import 'package:tsth_app/features/validation/domain/entities/plant.dart';

class PlantModel extends Plant {
  PlantModel({
    required super.id,
    required super.name,
    required super.latinName,
    required super.advantage,
    required super.ecology,
    required super.endemicInformation,
    required super.qrcode,
    required super.status,
    required super.habitus,
    required super.createdAt,
    required super.updatedAt,
    required super.deletedAt,
  });

  factory PlantModel.fromJson(Map<String, dynamic> json) {
    return PlantModel(
      id: json['id'],
      name: json['name'],
      latinName: json['latin_name'],
      advantage: json['advantage'],
      ecology: json['ecology'],
      endemicInformation: json['endemic_information'],
      qrcode: json['qrcode'],
      status: json['status'],
      habitus:
          json['habitus'] != null
              ? HabitusModel.fromJson(json['habitus'])
              : null,
      createdAt: json['created_at'],
      updatedAt: json['updated_at'],
      deletedAt: json['deleted_at'],
    );
  }
}
