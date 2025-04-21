import 'package:tsth_app/features/scanner/domain/entities/habitus.dart';

class Plant {
  final int? id;
  final String name;
  final String latinName;
  final String advantage;
  final String ecology;
  final String endemicInformation;
  final bool status;
  final String qrcode;
  final Habitus habitus;

  Plant({
    required this.id,
    required this.name,
    required this.latinName,
    required this.advantage,
    required this.ecology,
    required this.endemicInformation,
    required this.status,
    required this.habitus,
    required this.qrcode,
  });
}
