# ejemplo de API Rest en Laravel que conlleva los siguientes endpoints

## Restablecer las BD antes de iniciar la prueba (test)

```
POST/reset
200 OK
```

## Obtener saldo de cuenta no existente

```
GET/balance?account_id=6789
404 0
```

## Crear cuenta con balance inicial

```
POST/event {"tipo":"deposito","cuenta":"1234","monto":"100"}
201 {"cuenta":{"id":"1234","balance":"100"}}
```

## Depositar en cuenta existente

```
POST/event {"tipo":"deposito","cuenta":"1234","monto":"100"}
201 {"destinatario":{"id":"1234","balance":"200"}}
```

## Obtener balance de cuenta existente

```
GET/balance?account_id=1234
201 200
```

## Retirar de cuenta existente

```
POST/event {"tipo":"retiro","origen":"1234","monto":"50"}
201 {"origen":{"id":"1234","balance":"150"}}
```

## Retirar de cuenta no existente

```
POST/event {"tipo":"retiro","origen":"5678","monto":"100"}
404 0
```

## Tranferencia de cuenta existente

```
POST/event {"tipo":"transferencia","origen":"1234","monto":"150","destino":"300"}
201 {"origen":{"id":"1234","balance":"0"},"destino":{"id":"300","balance":"150"}}
```

## Tranferencia de cuenta no existente

```
POST/event {"tipo":"transferencia","origen":"5678","monto":"150","destino":"300"}
404 {"origen":{"id":"1234","balance":"0"},"destino":{"id":"300","balance":"150"}}
```
