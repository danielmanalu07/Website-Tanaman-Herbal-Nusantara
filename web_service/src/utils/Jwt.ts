import jwt from "jsonwebtoken";

interface AdminData {
  id: number | null;
  username: string | null;
  password: string | null;
}

const GenerateToken = (data: any): string => {
  const token = jwt.sign(data, process.env.JWT_TOKEN as string, {
    expiresIn: "10m",
  });

  return token;
};

const GenerateRefreshToken = (data: any): string => {
  const token = jwt.sign(data, process.env.JWT_REFRESH_TOKEN as string, {
    expiresIn: "1d",
  });

  return token;
};

const ExtractToken = (token: string): AdminData | null => {
  const secretKey: string = process.env.JWT_TOKEN as string;

  let resData: any;

  const res = jwt.verify(token, secretKey, (err, decoded) => {
    if (err) {
      resData = null;
    } else {
      resData = decoded;
    }
  });

  if (!resData) {
    return null;
  }
  const result: AdminData = <AdminData>resData;
  return result;
};

const ExtractRefreshToken = (token: string): AdminData | null => {
  const secretKey: string = process.env.JWT_REFRESH_TOKEN as string;

  let resData: any;

  const res = jwt.verify(token, secretKey, (err, decoded) => {
    if (err) {
      resData = null;
    } else {
      resData = decoded;
    }
  });

  if (!resData) {
    return null;
  }
  const result: AdminData = <AdminData>resData;
  return result;
};

export default {
  GenerateToken,
  GenerateRefreshToken,
  ExtractToken,
  ExtractRefreshToken,
};
