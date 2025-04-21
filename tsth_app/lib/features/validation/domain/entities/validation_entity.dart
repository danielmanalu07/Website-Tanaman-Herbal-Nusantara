class ValidationEntity {
  final int id;
  final String plantId;
  final String dateValidation;
  final String condition;
  final String description;
  final List<String> imagePaths;

  ValidationEntity({
    required this.id,
    required this.dateValidation,
    required this.condition,
    required this.description,
    required this.imagePaths,
    required this.plantId,
  });
}
