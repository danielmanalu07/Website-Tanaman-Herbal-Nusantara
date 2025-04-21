import 'package:flutter/material.dart';
import 'package:tsth_app/core/constant/color_constant.dart';

class CustomForm extends StatefulWidget {
  final String label;
  final TextEditingController controller;
  final bool isPassword;
  final TextInputType keyboardType;
  final double radius;
  final int? maxLines;
  final bool readOnly;

  const CustomForm({
    super.key,
    required this.label,
    required this.controller,
    required this.isPassword,
    required this.keyboardType,
    required this.radius,
    this.maxLines,
    this.readOnly = false,
  });

  @override
  State<CustomForm> createState() => _CustomFormState();
}

class _CustomFormState extends State<CustomForm> {
  bool _obscureText = true;

  @override
  void initState() {
    super.initState();
    // Initialize _obscureText based on isPassword
    _obscureText = widget.isPassword;
  }

  @override
  Widget build(BuildContext context) {
    return TextFormField(
      controller: widget.controller,
      obscureText: widget.isPassword ? _obscureText : false,
      keyboardType: widget.keyboardType,
      readOnly: widget.readOnly,
      maxLines: widget.isPassword ? 1 : (widget.maxLines ?? 1),
      decoration: InputDecoration(
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(widget.radius),
          borderSide: BorderSide(color: ColorConstant.greenColor, width: 2.0),
        ),
        labelText: widget.label,
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(widget.radius),
        ),
        suffixIcon:
            widget.isPassword
                ? IconButton(
                  icon: Icon(
                    _obscureText ? Icons.visibility_off : Icons.visibility,
                    color: Colors.grey,
                  ),
                  onPressed: () {
                    setState(() {
                      _obscureText = !_obscureText;
                    });
                  },
                )
                : null,
      ),
    );
  }
}
