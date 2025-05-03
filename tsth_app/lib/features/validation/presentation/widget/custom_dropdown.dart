import 'package:flutter/material.dart';
import 'package:tsth_app/core/constant/color_constant.dart';

class CustomDropdown extends StatefulWidget {
  final String label;
  final String? value;
  final List<String> items;
  final ValueChanged<String?>? onChanged;

  const CustomDropdown({
    super.key,
    required this.label,
    this.value,
    required this.items,
    this.onChanged,
  });

  @override
  State<CustomDropdown> createState() => _CustomDropdownState();
}

class _CustomDropdownState extends State<CustomDropdown>
    with SingleTickerProviderStateMixin {
  late AnimationController _animationController;
  late Animation<double> _scaleAnimation;
  late Animation<double> _fadeAnimation;
  bool _isDropdownOpen = false;

  @override
  void initState() {
    super.initState();
    _animationController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 300),
    );

    _scaleAnimation = Tween<double>(begin: 0.8, end: 1.0).animate(
      CurvedAnimation(parent: _animationController, curve: Curves.easeInOut),
    );

    _fadeAnimation = Tween<double>(begin: 0.0, end: 1.0).animate(
      CurvedAnimation(parent: _animationController, curve: Curves.easeInOut),
    );

    _animationController.forward();
  }

  @override
  void dispose() {
    _animationController.dispose();
    super.dispose();
  }

  void _toggleDropdown() {
    setState(() {
      _isDropdownOpen = !_isDropdownOpen;
      if (_isDropdownOpen) {
        _animationController.forward();
      } else {
        _animationController.reverse();
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          widget.label,
          style: const TextStyle(
            fontSize: 16,
            fontWeight: FontWeight.w500,
            color: Colors.black87,
          ),
        ),
        const SizedBox(height: 8),
        GestureDetector(
          onTap: _toggleDropdown,
          child: AnimatedContainer(
            duration: const Duration(milliseconds: 300),
            curve: Curves.easeInOut,
            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 16),
            decoration: BoxDecoration(
              color: ColorConstant.backgroundColor,
              borderRadius: BorderRadius.circular(12),
              border: Border.all(
                color:
                    _isDropdownOpen ? ColorConstant.greenColor : Colors.black38,
                width: 2,
              ),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(_isDropdownOpen ? 0.2 : 0.1),
                  blurRadius: 8,
                  offset: const Offset(0, 4),
                ),
              ],
            ),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  widget.value ?? 'Select ${widget.label}',
                  style: TextStyle(
                    fontSize: 16,
                    color: widget.value == null ? Colors.grey : Colors.black,
                  ),
                ),
                Icon(
                  _isDropdownOpen
                      ? Icons.keyboard_arrow_up
                      : Icons.keyboard_arrow_down,
                  color: ColorConstant.greenColor,
                ),
              ],
            ),
          ),
        ),
        if (_isDropdownOpen)
          AnimatedBuilder(
            animation: _animationController,
            builder: (context, child) {
              return Transform.scale(
                scale: _scaleAnimation.value,
                child: Opacity(
                  opacity: _fadeAnimation.value,
                  child: Container(
                    margin: const EdgeInsets.only(top: 8),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(12),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.1),
                          blurRadius: 8,
                          offset: const Offset(0, 4),
                        ),
                      ],
                    ),
                    child: ClipRRect(
                      borderRadius: BorderRadius.circular(12),
                      child: Column(
                        children:
                            widget.items.map((item) {
                              return GestureDetector(
                                onTap: () {
                                  widget.onChanged?.call(item);
                                  _toggleDropdown();
                                },
                                child: Container(
                                  padding: const EdgeInsets.symmetric(
                                    horizontal: 12,
                                    vertical: 16,
                                  ),
                                  color:
                                      widget.value == item
                                          ? ColorConstant.greenColor
                                              .withOpacity(0.1)
                                          : Colors.white,
                                  child: Row(
                                    mainAxisAlignment:
                                        MainAxisAlignment.spaceBetween,
                                    children: [
                                      Text(
                                        item,
                                        style: TextStyle(
                                          fontSize: 16,
                                          color:
                                              widget.value == item
                                                  ? ColorConstant.greenColor
                                                  : Colors.black,
                                          fontWeight:
                                              widget.value == item
                                                  ? FontWeight.bold
                                                  : FontWeight.normal,
                                        ),
                                      ),
                                      if (widget.value == item)
                                        const Icon(
                                          Icons.check,
                                          color: ColorConstant.greenColor,
                                          size: 20,
                                        ),
                                    ],
                                  ),
                                ),
                              );
                            }).toList(),
                      ),
                    ),
                  ),
                ),
              );
            },
          ),
      ],
    );
  }
}
