import 'dart:convert';

import 'package:http/http.dart' as http;
import 'package:tsth_mobile_apps/core/constant/api_constant.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/data/model/habitus_model.dart';
import 'package:tsth_mobile_apps/utils/jwt_utils.dart';

class HabitusRemoteDataSource {
  final http.Client _client;

  HabitusRemoteDataSource({http.Client? client})
      : _client = client ?? http.Client();

  Future<List<HabitusModel>> getHabitus() async {
    try {
      final token = await JwtUtils.getToken();

      if (token == null || token.isEmpty) {
        throw Exception("Token not found, please login again.");
      }

      final response = await _client.get(
        Uri.parse('${ApiConstant.BASE_URL}/habitus'),
        headers: {
          "Content-Type": "application/json",
          "Cache-Control": "no-cache",
          "Authorization": "Bearer $token",
        },
      ).timeout(
        const Duration(seconds: 5),
        onTimeout: () {
          throw Exception('Request timeout. Please check your connection.');
        },
      );

      print("Respon Body (Get Habitus): ${response.body}");

      if (response.statusCode == 200) {
        final Map<String, dynamic> responseData = jsonDecode(response.body);
        final List<dynamic> data = responseData["data"];
        return data.map((json) => HabitusModel.fromJson(json)).toList();
      } else if (response.statusCode == 401) {
        await JwtUtils.deleteToken();
        throw Exception("Session expired, please login again.");
      } else {
        final responseData = jsonDecode(response.body);
        String errorMessage =
            responseData['message'] ?? 'Failed to fetch habitus';
        throw Exception(errorMessage);
      }
    } catch (e) {
      rethrow;
    }
  }
}
