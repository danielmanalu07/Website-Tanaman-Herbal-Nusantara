import 'package:another_flushbar/flushbar.dart';
import 'package:flutter/material.dart';
import 'package:tsth_app/core/constant/color_constant.dart';

class CustomSnackbar {
  static void alert(BuildContext context, String message, bool isError) {
    Flushbar(
      message: message,
      backgroundColor:
          isError ? ColorConstant.errorColor : ColorConstant.successColor,
      duration: Duration(seconds: 2),
      flushbarPosition: FlushbarPosition.TOP,
      borderRadius: BorderRadius.circular(10),
      margin: EdgeInsets.all(16),
      padding: EdgeInsets.symmetric(horizontal: 20, vertical: 16),
      messageColor: ColorConstant.whiteColor,
    ).show(context);
  }
}
