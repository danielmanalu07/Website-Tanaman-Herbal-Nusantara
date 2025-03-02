import 'package:flutter/material.dart';
import 'package:tsth_mobile_apps/core/constant/color_constant.dart';

class CustomCardHabitus extends StatelessWidget {
  final String name;
  final VoidCallback onPressed;

  const CustomCardHabitus({
    super.key,
    required this.name,
    required this.onPressed,
  });

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onPressed,
      child: Card(
        color: ColorConstant.background,
        elevation: 2,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: <Widget>[
              Text(
                name,
                style: const TextStyle(
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                  color: Colors.black,
                ),
              ),
              const Icon(Icons.arrow_right, size: 32),
            ],
          ),
        ),
      ),
    );
  }
}
