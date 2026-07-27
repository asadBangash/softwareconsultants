#!/usr/bin/env python3
"""Local dev server with clean URL support (mirrors .htaccess rules)."""

import http.server
import os
import socketserver
import urllib.parse

PORT = 8000
ROOT = os.path.dirname(os.path.abspath(__file__))

ROUTE_MAP = {
    "/": "index.html",
    "/home": "index.html",
    "/services": "services/index.html",
    "/industries": "industries/index.html",
}


class CleanURLHandler(http.server.SimpleHTTPRequestHandler):
    def __init__(self, *args, **kwargs):
        super().__init__(*args, directory=ROOT, **kwargs)

    def do_GET(self):
        parsed = urllib.parse.urlparse(self.path)
        path = urllib.parse.unquote(parsed.path)
        clean_path = path.rstrip("/") or "/"
        query = ("?" + parsed.query) if parsed.query else ""

        if clean_path.endswith(".html"):
            redirect = "/" if clean_path == "/index.html" else clean_path[:-5]
            self.send_response(301)
            self.send_header("Location", redirect + query)
            self.end_headers()
            return

        if clean_path in ROUTE_MAP:
            self.path = "/" + ROUTE_MAP[clean_path] + query
            return super().do_GET()

        html_path = clean_path.lstrip("/") + ".html"
        if os.path.isfile(os.path.join(ROOT, html_path)):
            self.path = "/" + html_path + query
            return super().do_GET()

        return super().do_GET()


if __name__ == "__main__":
    with socketserver.TCPServer(("", PORT), CleanURLHandler) as httpd:
        print("=" * 50)
        print(" Software Consultants - Dev Server")
        print("=" * 50)
        print(f" Open: http://localhost:{PORT}/")
        print(" Clean URLs enabled (no .html in address bar)")
        print(" Press Ctrl+C to stop")
        print("=" * 50)
        httpd.serve_forever()
