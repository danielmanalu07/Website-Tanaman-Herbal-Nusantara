const ResponseError = (
  status_code: number,
  message: string | null,
  error: string | null
) => {
  const response = {
    status_code: status_code,
    message: message,
    errors: error,
  };
  return response;
};

export default { ResponseError };
