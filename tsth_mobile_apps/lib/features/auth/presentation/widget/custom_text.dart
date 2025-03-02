import 'package:flutter/widgets.dart';

class CustomText extends StatelessWidget {
  final String text;
  final Color colors;
  final double size;
  final FontWeight fontWeight;
  const CustomText(
      {super.key,
      required this.text,
      required this.colors,
      required this.size,
      required this.fontWeight});

  @override
  Widget build(BuildContext context) {
    return Text(
      text,
      style: TextStyle(
        fontSize: size,
        color: colors,
        fontFamily: 'Poppins',
        fontWeight: fontWeight,
      ),
    );
  }
}
