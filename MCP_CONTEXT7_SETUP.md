# Настройка MCP Context7 в Cursor

## Что было сделано

✅ **MCP Context7 успешно добавлен в Cursor!**

### Конфигурация
Файл `/home/evgeny/.cursor/mcp.json` обновлен со следующей конфигурацией:

```json
{
  "mcpServers": {
    "context7": {
      "command": "npx",
      "args": ["-y", "@upstash/context7-mcp@latest"]
    }
  }
}
```

### Системные требования
- ✅ Node.js v20.18.1 (требуется ≥18.0.0)
- ✅ npx v9.2.0
- ✅ MCP сервер Context7 установлен и протестирован

## Как использовать

1. **Перезапустите Cursor** для применения изменений
2. **В запросах к AI** добавьте `use context7` для получения актуальной документации и примеров кода
3. **Для расширенных возможностей** (высокие лимиты запросов) получите API-ключ на [context7.com/dashboard](https://context7.com/dashboard)

## Пример использования

```
use context7: Как создать REST API в Yii2?
```

Context7 предоставит актуальную документацию и примеры кода для Yii2.

## Дополнительная информация

- Официальная документация: [GitHub Context7](https://github.com/upstash/context7)
- Поддержка: Context7 MCP сервер готов к использованию
