import 'dart:convert';

import 'package:tsth_app/core/constant/api_constant.dart';
import 'package:tsth_app/features/scanner/data/model/plant_model.dart';
import 'package:http/http.dart' as http;

class PlantRemoteDataSource {
  Future<PlantModel> getPlantById(int id) async {
    final response = await http.get(
      Uri.parse("${ApiConstant.api}/plants-user/$id"),
    );

    if (response.statusCode == 200) {
      final jsonData = jsonDecode(response.body)['data'];
      print("data plant : ${jsonData}");
      return PlantModel.fromJson(jsonData);
    } else {
      throw Exception("Failed to fetch plant data");
    }
  }
}
