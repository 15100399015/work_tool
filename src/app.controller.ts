import { Body, Controller, Post, Res } from '@nestjs/common';
import { AppService } from './app.service';
import { Response } from 'express';
import { VerArrPipe, VerObjPipe, VerStrPipe } from './app.pipe';

@Controller()
export class AppController {
  constructor(private readonly appService: AppService) {}
  @Post('bdOcpcRedirect')
  async bdOcpcRedirect(@Body('token', new VerStrPipe()) _token, @Body('conversionTypes', new VerArrPipe()) _conversionTypes, @Res() res: Response) {
    const { headers, data, status } = await this.appService.bdOcpcRedirect(_token, _conversionTypes);
    Object.keys(headers).forEach(key => {
      res.setHeader(key, headers[key]);
    });
    res.status(status).send(data);
  }
  @Post('jDataApi')
  async jDataApi(@Body('formToken', new VerStrPipe()) _formToken, @Body('authToken', new VerStrPipe()) _authToken, @Body('data', new VerObjPipe()) _data, @Res() res: Response) {
    const { headers, data, status } = await this.appService.jDataApi(_formToken, _authToken, _data);
    Object.keys(headers).forEach(key => {
      res.setHeader(key, headers[key]);
    });
    res.status(status).send(data);
  }
}
