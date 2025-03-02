import 'dart:convert';

import 'package:tsth_mobile_apps/core/constant/api_constant.dart';
import 'package:tsth_mobile_apps/features/auth/data/model/user_model.dart';
import 'package:http/http.dart' as http;

class AuthRemoteDataSource {
  final http.Client _client;

  AuthRemoteDataSource({http.Client? client})
      : _client = client ?? http.Client();

  Future<UserModel> login(String username, String password) async {
    try {
      final response = await _client
          .post(
        Uri.parse('${ApiConstant.BASE_URL}/login'),
        headers: {
          "Content-Type": "application/json",
          "Cache-Control": "no-cache",
        },
        body: jsonEncode({'username': username, 'password': password}),
      )
          .timeout(
        const Duration(seconds: 5),
        onTimeout: () {
          throw Exception('Request timeout. Please check your connection.');
        },
      );

      print("Respon Body (Login): ${response.body}");

      final responseData = jsonDecode(response.body);
      if (response.statusCode == 200) {
        return UserModel.fromJson(responseData);
      } else {
        String errorMessage = responseData['message'] ?? 'Login Failed';
        throw Exception(errorMessage);
      }
    } on http.ClientException catch (e) {
      throw Exception("Network Error: $e");
    } catch (e) {
      rethrow;
    }
  }
}
