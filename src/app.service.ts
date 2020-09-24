import { Injectable, HttpService } from '@nestjs/common';

@Injectable()
export class AppService {
  constructor(private readonly httpService: HttpService) {}
  // 百度api转发
  bdOcpcRedirect(token, conversionTypes) {
    return this.httpService
      .request({
        method: 'post',
        url: 'https://ocpc.baidu.com/ocpcapi/api/uploadConvertData',
        data: { token, conversionTypes },
      })
      .toPromise()
      .then(({ status, headers, data }) => ({ status, headers, data }))
      .catch(({ response: { status, headers, data } }) => ({ status, headers, data }));
  }
  // 金数据api
  jDataApi(formToken, authToken, data) {
    // 请求金数据服务器
    return this.httpService
      .request({
        method: 'post',
        url: `https://jinshuju.net/api/v1/forms/${formToken}`,
        headers: {
          Authorization: `Basic ${authToken}`,
        },
        data,
      })
      .toPromise()
      .then(({ status, headers, data }) => ({ status, headers, data }))
      .catch(({ response: { status, headers, data } }) => ({ status, headers, data }));
  }
}
