import 'package:flutter/material.dart';
import 'package:tsth_app/core/constant/color_constant.dart';

class CustomDatePicker extends StatelessWidget {
  final String label;
  final TextEditingController controller;
  final VoidCallback onTap;

  const CustomDatePicker({
    super.key,
    required this.label,
    required this.controller,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller,
      readOnly: true,
      onTap: onTap,
      decoration: InputDecoration(
        labelText: label,
        labelStyle: TextStyle(color: ColorConstant.blackColor),
        floatingLabelStyle: TextStyle(color: ColorConstant.greenColor),
        border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide(color: ColorConstant.blackColor, width: 1.0),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide(color: ColorConstant.greenColor, width: 2.0),
        ),
        suffixIcon: Icon(Icons.calendar_today, color: ColorConstant.greenColor),
      ),
    );
  }
}
