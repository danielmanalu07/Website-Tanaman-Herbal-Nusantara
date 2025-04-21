import 'dart:convert';

import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import 'package:tsth_app/core/constant/api_constant.dart';
import 'package:tsth_app/core/utils/auth_utils.dart';
import 'package:tsth_app/features/validation/data/model/validation_model.dart';
import 'package:tsth_app/features/validation/domain/entities/validation.dart';
import 'package:tsth_app/features/validation/domain/entities/validation_entity.dart';

class ValidationRemoteDatasource {
  final http.Client client;

  ValidationRemoteDatasource(this.client);

  Future<void> saveValidation(ValidationEntity validation) async {
    final uri = Uri.parse('${ApiConstant.api}/scanner/validate');

    final token = await AuthUtils.getToken();

    final request =
        http.MultipartRequest('POST', uri)
          ..fields['date_validation'] = validation.dateValidation
          ..fields['condition'] = validation.condition
          ..fields['description'] = validation.description
          ..fields['plant_id'] = validation.plantId
          ..headers['Authorization'] = 'Bearer $token';

    for (var path in validation.imagePaths) {
      request.files.add(await http.MultipartFile.fromPath('images[]', path));
    }

    final response = await request.send();
    final responseBody = await response.stream.bytesToString();

    print('Sending request to $uri');
    print('Fields: ${request.fields}');
    print('Files: ${request.files.map((f) => f.filename)}');

    if (response.statusCode == 200) {
      print('Success: $responseBody');
    } else {
      print('Failed: ${response.statusCode}, body: $responseBody');
      throw Exception('Failed to save validation: $responseBody');
    }
  }

  Future<List<Validation>> get_all_validated() async {
    final uri = Uri.parse('${ApiConstant.api}/validated');
    final token = await AuthUtils.getToken();

    try {
      final response = await client.get(
        uri,
        headers: {
          'Authorization': 'Bearer $token',
          'Accept': 'application/json',
        },
      );

      print('Response status: ${response.statusCode}');
      debugPrint('Response body: ${response.body}'); // For debugging

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        final List<dynamic> validationData = data['data'];
        print("validated count: ${validationData.length}");

        List<Validation> validations = [];

        for (var item in validationData) {
          try {
            validations.add(ValidationModel.fromJson(item));
          } catch (e) {
            print('Error parsing validation: $e');
          }
        }

        return validations;
      } else {
        throw Exception('Failed to fetch validated data: ${response.body}');
      }
    } catch (e) {
      print('Exception in get_all_validated: $e');
      throw Exception('Failed to fetch validations: $e');
    }
  }

  Future<Validation> get_detail_validated(int id) async {
    final uri = Uri.parse('${ApiConstant.api}/validated/$id');
    final token = await AuthUtils.getToken();

    try {
      final response = await client.get(
        uri,
        headers: {
          'Authorization': 'Bearer $token',
          'Accept': 'application/json',
        },
      );

      final dataJson = jsonDecode(response.body);
      if (response.statusCode == 200) {
        return ValidationModel.fromJson(dataJson['data']);
      } else {
        throw Exception('Failed to fetch validated data: ${response.body}');
      }
    } catch (e) {
      print('Exception in get_all_validated: $e');
      throw Exception('Failed to fetch validations: $e');
    }
  }
}
