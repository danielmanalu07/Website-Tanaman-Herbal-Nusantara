import { NextFunction, Request, Response } from "express";
import Validator from "validatorjs";
import Admin from "../../../domain/models/Admin";

const LoginValidation = async (
  req: Request,
  res: Response,
  next: NextFunction
): Promise<void> => {
  try {
    const { username, password } = req.body;

    const data = {
      username,
      password,
    };

    const rules: Validator.Rules = {
      username: "required|string",
      password: "required|min:8",
    };

    const validate = new Validator(data, rules);

    if (validate.fails()) {
      res.status(400).json({
        status_code: 400,
        messsage: "Bad Request",
        errors: validate.errors,
      });
      return;
    }
    const admin = await Admin.findOne({
      where: {
        username: data.username,
      },
    });

    if (!admin) {
      res.status(404).json({
        status_code: 400,
        message: "Data not found",
      });
      return;
    }

    next();
  } catch (error) {
    res.status(500).json({
      status_code: 500,
      errors: error,
    });
    return;
  }
};

export default { LoginValidation };
