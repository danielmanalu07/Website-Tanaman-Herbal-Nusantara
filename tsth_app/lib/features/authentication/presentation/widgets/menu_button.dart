import 'package:flutter/material.dart';
import 'package:tsth_app/core/constant/color_constant.dart';

class MenuButton extends StatelessWidget {
  final IconData icon;
  final String label;
  final double angle;
  final double bottomPadding;
  final double size;
  final VoidCallback? onPressed;

  const MenuButton({
    super.key,
    required this.icon,
    required this.label,
    this.angle = 0,
    this.bottomPadding = 0,
    required this.size,
    this.onPressed,
  });

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: EdgeInsets.only(bottom: bottomPadding),
      child: Transform.rotate(
        angle: angle,
        alignment: Alignment.center,
        child: GestureDetector(
          onTap: onPressed,
          child: ClipPath(
            clipper: InvertedTrapezoidClipper(),
            child: Container(
              width: size,
              height: size,
              decoration: BoxDecoration(
                color: ColorConstant.backgroundColor,
                boxShadow: [
                  BoxShadow(
                    color: ColorConstant.blackColor.withOpacity(0.1),
                    blurRadius: 8,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Container(
                    width: size * 0.4,
                    height: size * 0.4,
                    decoration: const BoxDecoration(
                      color: ColorConstant.whiteColor,
                      shape: BoxShape.circle,
                    ),
                    child: Icon(
                      icon,
                      color: ColorConstant.grayColor,
                      size: size * 0.24,
                    ),
                  ),
                  SizedBox(height: size * 0.06),
                  Text(
                    label,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: ColorConstant.greenColor,
                      fontSize: size * 0.1,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}

class InvertedTrapezoidClipper extends CustomClipper<Path> {
  @override
  Path getClip(Size size) {
    double width = size.width;
    double height = size.height;
    double cut = width * 0.16;
    double radius = width * 0.1;

    Path path = Path();

    path.moveTo(0 + radius, 0);
    path.lineTo(width - radius, 0);
    path.quadraticBezierTo(width, 0, width, 0 + radius);
    path.lineTo(width - cut, height - radius);
    path.quadraticBezierTo(width - cut, height, width - cut - radius, height);
    path.lineTo(cut + radius, height);
    path.quadraticBezierTo(cut, height, cut, height - radius);
    path.lineTo(0, 0 + radius);
    path.quadraticBezierTo(0, 0, 0 + radius, 0);

    path.close();
    return path;
  }

  @override
  bool shouldReclip(CustomClipper<Path> oldClipper) => false;
}
