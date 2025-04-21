import 'package:tsth_app/features/validation/domain/entities/habitus.dart';

class Plant {
  final int id;
  final String name;
  final String latinName;
  final String advantage;
  final String ecology;
  final String endemicInformation;
  final String qrcode;
  final int status;
  final Habitus? habitus;
  final String? createdAt;
  final String? updatedAt;
  final String? deletedAt;

  Plant({
    required this.id,
    required this.name,
    required this.latinName,
    required this.advantage,
    required this.ecology,
    required this.endemicInformation,
    required this.qrcode,
    required this.status,
    required this.habitus,
    this.createdAt,
    this.updatedAt,
    this.deletedAt,
  });
}
