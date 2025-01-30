import { NextFunction, Request, Response } from "express";
import Jwt from "../../../utils/Jwt";

const Authenticated = (
  req: Request,
  res: Response,
  next: NextFunction
): any => {
  try {
    const authToken = req.headers["authorization"];
    const token = authToken && authToken.split(" ")[1];

    if (token === null) {
      return res.status(401).json({
        status_code: 401,
        message: "Unauthorized",
      });
    }

    const result = Jwt.ExtractToken(token!);
    if (!result) {
      return res.status(401).json({
        status_code: 401,
        message: "Unauthorized",
      });
    }

    res.locals.userId = result?.id;
    next();
  } catch (error) {
    return res.status(500).json({
      status_code: 500,
      message: "Internal Server Error",
      errors: error,
    });
  }
};

export default { Authenticated };
