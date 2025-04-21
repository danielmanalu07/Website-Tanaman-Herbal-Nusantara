import 'package:tsth_app/features/validation/domain/entities/validation.dart';

abstract class ValidationLocalDatasource {
  List<Validation> getValidations();
  Future<Validation> getDetailValidations(int id);
}

// class ValidationLocalDatasourceImpl implements ValidationLocalDatasource {
//   @override
//   // List<Validation> getValidations() {
//   //   final habitus = Habitus(id: 1, name: "Pohon");
//   //   final plant = Plant(
//   //     id: 1,
//   //     name: "Kemiri",
//   //     latinName: "Aleurites moluccanus",
//   //     advantage: "Used for oil production",
//   //     ecology: "Grows in tropical regions",
//   //     endemicInformation: "Native to Southeast Asia",
//   //     qrcode: "QR123456",
//   //     status: "Validated",
//   //     habitus: habitus,
//   //   );

//     // return List.generate(
//     //   10,
//     //   (index) => Validation(
//     //     id: index + 1,
//     //     image: "assets/images/kemiri.png",
//     //     description: "Validation for kemiri plant",
//     //     date: "2023-10-01",
//     //     plant: plant,
//     //     condition: 'Baik',
//     //   ),
//     // );
//   }

//   Future<Validation> getDetailValidations(int id) async {
//     await Future.delayed(const Duration(seconds: 1));
//     final validations = getValidations();

//     try {
//       final validation = validations.firstWhere((v) => v.id == id);
//       return validation;
//     } catch (e) {
//       throw Exception("Validation with id $id not found");
//     }
//   }
// }
