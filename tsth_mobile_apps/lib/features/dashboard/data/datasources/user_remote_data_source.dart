import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:tsth_mobile_apps/core/constant/api_constant.dart';
import 'package:tsth_mobile_apps/features/dashboard/data/model/user_model.dart';
import 'package:tsth_mobile_apps/utils/jwt_utils.dart';

class UserRemoteDataSource {
  final http.Client _client;

  UserRemoteDataSource({http.Client? client})
      : _client = client ?? http.Client();

  Future<UserModel> getProfile() async {
    try {
      final token = await JwtUtils.getToken();

      if (token == null || token.isEmpty) {
        throw Exception("Token not found, please login again.");
      }

      final response = await _client.get(
        Uri.parse('${ApiConstant.BASE_URL}/profile'),
        headers: {
          "Content-Type": "application/json",
          "Cache-Control": "no-cache",
          "Authorization": "Bearer $token",
        },
      );

      print("Respon Body (Get Profile): ${response.body}");

      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        return UserModel.fromJson(responseData);
      } else if (response.statusCode == 401) {
        await JwtUtils.deleteToken();
        throw Exception("Session expired, please login again.");
      } else {
        final responseData = jsonDecode(response.body);
        String errorMessage =
            responseData['message'] ?? 'Failed to fetch profile';
        throw Exception(errorMessage);
      }
    } catch (e) {
      rethrow;
    }
  }

  Future<void> logout() async {
    try {
      final token = await JwtUtils.getToken();

      if (token == null || token.isEmpty) {
        throw Exception("Token not found, please login again.");
      }

      final response = await _client.post(
        Uri.parse('${ApiConstant.BASE_URL}/logout'),
        headers: {
          "Content-Type": "application/json",
          "Authorization": "Bearer $token",
        },
      );

      print("Respon Body (Logout): ${response.body}");

      if (response.statusCode == 200) {
        return await JwtUtils.deleteToken();
      } else {
        final responseData = jsonDecode(response.body);
        String errorMessage = responseData['message'] ?? 'Failed to logout';
        throw Exception(errorMessage);
      }
    } catch (e) {
      rethrow;
    }
  }
}
